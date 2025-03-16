import Swal from "sweetalert2";

$(document).ready(function () {
    $("#createOrangtua").on("submit", function (e) {
        e.preventDefault();

        const formData = {
            nama_lengkap: $("#nama_lengkap").val(),
            no_tlp: $("#no_tlp").val(),
            email: $("#email").val(),
            alamat: $("#alamat").val(),
            password: $("#password").val(),
        };

        $.ajax({
            url: "/api/orang-tua/add-ortu",
            method: "POST",
            data: formData,
            headers: {
                Authorization: `Bearer ${token}`,
            },
            beforeSend: function () {
                $("#table-loading").removeClass("d-none");
            },
            success: function (response) {
                Swal.fire({
                    title: "Berhasil Membuat Akun!",
                    text: "Akun Anda telah berhasil dibuat.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });

                $("#exampleModal").modal("hide");
                $("#createOrangtua")[0].reset();

                // window.location.reload();
            },
            error: function (xhr) {
                let error;
                try {
                    error = xhr.responseJSON;
                } catch (e) {
                    console.log("Error parsing JSON Response:", e);
                    Swal.fire({
                        title: "Error!",
                        text: "Terjadi kesalahan tak dikenal.",
                        icon: "error",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                    return;
                }
                if (xhr.status === 422 && errors) {
                    let errorMessage = "";
                    $.each(errors, function (key, value) {
                        errorMessage += value[0] + "<br>";
                    });

                    Swal.fire({
                        title: "Error!",
                        html: errorMessage,
                        icon: "error",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "Terjadi kesalahan tak dikenal.",
                        icon: "error",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                }
            },
            complete: function () {
                $("#table-loading").addClass("d-none");
            },
        });
    });

    let currentPage = 1;
    let searchQuery = "";

    const fetchOrangtua = (page = 1, search = "") => {
        $.ajax({
            url: "/api/orang-tua",
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            data: {
                page: page,
                search: search,
            },
            dataType: "json",
            beforeSend: function () {
                $("#table-loading").removeClass("d-none");
            },
            success: function (data) {
                if (!data.data || data.data.length === 0) {
                    $("#dataTable tbody").html(
                        `<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>`
                    );
                    $("#pagination").empty();
                    return;
                }

                $("#dataTable tbody").empty();
                const currentPage = data.current_page || 1;
                const perPage = data.per_page || data.data.length;
                const offset = (currentPage - 1) * perPage;
                const OrangTuaData = data.data || data;

                $.each(OrangTuaData, function (index, user) {
                    $("#dataTable tbody").append(
                        `<tr>
                            <td>${offset + index + 1}</td>
                            <td>${user.nama_lengkap}</td>
                            <td>${user.no_tlp}</td>
                            <td>${user.email}</td>
                            <td>${user.alamat}</td>
                            <td class="text-center">
                                <button class="btn btn-warning" onclick="editUser(${
                                    user.id
                                })">
                                    <i class="fas fa-edit text-white"></i>
                                </button>
                                <button class="btn btn-danger" onclick="deleteUser(${
                                    user.id
                                })">
                                  <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`
                    );
                });

                renderPagination(data);
            },
            error: function (xhr) {
                console.error("Error loading orangtua:", xhr.responseJSON);
                $("#dataTable tbody").html(
                    `<tr><td colspan="6" class="text-center text-danger">Terjadi kesalahan</td></tr>`
                );
            },
            complete: function () {
                $("#table-loading").addClass("d-none");
            },
        });
    };

    function renderPagination(data) {
        const paginationLinks = $("#pagination");
        paginationLinks.empty();

        if (data.links && data.links.length > 0) {
            $.each(data.links, function (index, link) {
                paginationLinks.append(
                    `<button class="btn btn-light ${
                        link.active ? "active" : ""
                    }"
                              data-page="${
                                  link.url ? link.url.split("page=")[1] : ""
                              }"
                              ${!link.url ? "disabled" : ""}>
                        ${link.label}
                    </button>`
                );
            });

            $("#pagination button").click(function () {
                const page = $(this).data("page");
                if (page) {
                    fetchOrangtua(page, $("#search-input").val());
                }
            });
        }
    }

    $("#search-input").on("input", function () {
        searchQuery = $(this).val();
        fetchOrangtua(1, searchQuery);
    });

    fetchOrangtua(currentPage, searchQuery);

    // Start Modal Edit
    window.editUser = function (id) {
        $.ajax({
            url: `/api/orang-tua/${id}`,
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            success: function (response) {
                if (!response.data) {
                    console.error("Data user tidak ditemukan!");
                    return;
                }

                const user = response.data;

                $("#editUserId").val(user.id);
                $("#editNamaLengkap").val(user.nama_lengkap);
                $("#editNoTlp").val(user.no_tlp);
                $("#editEmail").val(user.email);
                $("#editAlamat").val(user.alamat);

                $("#editUserModal").modal("show");
            },
            error: function (xhr) {
                console.error("Gagal mengambil data user:", xhr.responseJSON);
                alert("Terjadi kesalahan saat mengambil data!");
            },
        });
    };
    // End Modal Edit
    $("#saveChanges").on("click", function () {
        const userId = $("#editUserId").val();
        const formEdit = {
            nama_lengkap: $("#editNamaLengkap").val(),
            no_tlp: $("#editNoTlp").val(),
            email: $("#editEmail").val(),
            alamat: $("#editAlamat").val(),
            password: $("#editPassword").val() || null,
        };
        const password = $("#editPassword").val();
        if (password) {
            formEdit.password = password;
        }

        $.ajax({
            url: `/api/orang-tua/${userId}/update-ortu`,
            method: "PUT",
            data: JSON.stringify(formEdit),
            contentType: "application/json",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            success: function (response) {
                Swal.fire({
                    title: "Data Berhasil Di Update",
                    text: "Data telah berhasil Di Update.",
                    icon: "success",
                    showConfirmButton: false,
                });
                $("#editUserModal").modal("hide");
            },
            error: function (xhr) {
                console.error("Error updating user:", xhr.responseText);

                let errorMessage = "Gagal memperbarui data pengguna.";
                if (xhr.responseJSON) {
                    const errors = Object.entries(xhr.responseJSON).map(
                        ([field, messages]) => {
                            return `${
                                field.charAt(0).toUpperCase() + field.slice(1)
                            }: ${messages.join(", ")}`;
                        }
                    );
                    errorMessage = errors.join(" | ");
                }

                Swal.fire({
                    title: "Error!",
                    text: errorMessage,
                    icon: "error",
                });
            },
        });
    });
    // Start Modal Delet
    let userIdToDelete;

    window.deleteUser = function (id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data ini akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/orang-tua/${id}/delete-ortu`,
                    method: "DELETE",
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Dihapus!",
                            text: "Data telah berhasil dihapus.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        });

                        // Refresh data setelah penghapusan
                        setTimeout(() => {
                            fetchOrangtua(); // Pastikan fungsi ini ada untuk memuat ulang tabel
                        }, 2000);
                    },
                    error: function (xhr) {
                        console.error("Error deleting user:", xhr.responseText);
                        Swal.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menghapus data.",
                            icon: "error",
                        });
                    },
                });
            }
        });
    };

    // End Modal Delete

    function loadNotifications() {
        $.ajax({
            url: "/api/orang-tua/notifications",
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            success: function (response) {
                console.log("Response dari API:", response);
                let notifContainer = $("#notification-list");
                notifContainer.empty();

                let notifications = response.notifications || [];

                if (notifications.length === 0) {
                    notifContainer.append(
                        '<li class="dropdown-item text-center">Tidak ada notifikasi</li>'
                    );
                    return;
                }

                if (
                    !response.notifications ||
                    response.notifications.length === 0
                ) {
                    console.log("Notifikasi kosong atau tidak ditemukan.");
                }
                $.each(response.notifications, function (index, notif) {
                    notifContainer.append(`
                        <li class="dropdown-item">
                            ${notif.data.message} 
                            <small class="text-muted">${new Date(
                                notif.created_at
                            ).toLocaleString()}</small>
                        </li>
                    `);
                });

                $("#notif-badge").text(response.notifications.length);
            },
            error: function (xhr) {
                console.error("Gagal mengambil notifikasi:", xhr.responseText);
            },
        });
    }

    // Panggil fungsi saat halaman dimuat
    loadNotifications();
});
