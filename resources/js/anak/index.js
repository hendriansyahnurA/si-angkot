import { data } from "jquery";
import Swal from "sweetalert2";

$(document).ready(function () {
    $.ajax({
        url: "/api/anak/show-ortu",
        method: "GET",
        headers: {
            Authorization: `Bearer ${token}`,
        },
        dataType: "json",
        success: function (response) {
            let select = $("#user_id");
            select.empty();
            select.append(`<option selected disabled>Pilih Orang Tua</option>`);

            let orangtuaList = response.data || response;

            $.each(orangtuaList, function (index, orangtua) {
                select.append(
                    `<option value="${orangtua.id}">${orangtua.nama_lengkap}</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            console.error("Gagal mengambil data:", error);
        },
    });

    $("#createAnak").on("submit", function (e) {
        e.preventDefault();

        const formData = {
            nama_lengkap: $("#nama_lengkap").val(),
            nisn: $("#nisn").val(),
            sekolah: $("#sekolah").val(),
            alamat_sekolah: $("#alamat_sekolah").val(),
            no_tlp: $("#no_tlp").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            user_id: $("#user_id").val(),
        };

        $.ajax({
            url: "/api/anak/add-anak",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(formData),
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
                $("#createAnak")[0].reset(); // Fixed form reset selector
            },
            error: function (xhr) {
                let errorMessage = "Terjadi kesalahan tak dikenal.";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors)
                        .map((err) => err[0])
                        .join("<br>");
                }

                Swal.fire({
                    title: "Error!",
                    html: errorMessage,
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: false,
                });
            },
            complete: function () {
                $("#table-loading").addClass("d-none");
            },
        });
    });

    let currentPage = 1;
    let searchQuery = "";

    const fetchAnak = (page = 1, search = "") => {
        $.ajax({
            url: "/api/anak",
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
                        `<tr><td colspan="10" class="text-center">Data tidak ditemukan</td></tr>`
                    );
                    $("#pagination").empty();
                    return;
                }

                $("#dataTable tbody").empty();
                const currentPage = data.current_page || 1;
                const perPage = data.per_page || data.data.length;
                const offset = (currentPage - 1) * perPage;

                $.each(data.data, function (index, user) {
                    const namaOrangTua = user.orangtua
                        ? user.orangtua.nama_lengkap
                        : "-";
                    const statusText = user.status || "Belum Verifikasi";

                    let statusButton = `<button class="btn btn-warning btn-sm" onclick="verifikasiAnak(${user.id})">${statusText}</button>`;
                    if (statusText.toLowerCase() === "verified") {
                        statusButton = `<button class="btn btn-success btn-sm">${statusText}</button>`;
                    }

                    $("#dataTable tbody").append(
                        `<tr>
                            <td>${offset + index + 1}</td>
                            <td>${user.nama_lengkap}</td>
                            <td>${user.nisn}</td>
                            <td>${namaOrangTua}</td>
                            <td>${user.no_tlp}</td>
                            <td>${user.sekolah}</td>
                            <td>${user.email}</td>
                            <td>${user.alamat_sekolah}</td>
                            <td class="text-center">${statusButton}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" onclick="editUser(${
                                    user.id
                                })">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(${
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
                console.error("Error loading data:", xhr.responseJSON);
                $("#dataTable tbody").html(
                    `<tr><td colspan="10" class="text-center text-danger">Terjadi kesalahan saat memuat data</td></tr>`
                );
            },
            complete: function () {
                $("#table-loading").addClass("d-none");
            },
        });
    };

    // Definisikan fungsi verifikasiAnak dalam window scope
    window.verifikasiAnak = function (id) {
        Swal.fire({
            title: "Verifikasi Akun?",
            text: "Apakah Anda yakin ingin memverifikasi akun ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Verifikasi",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/admin/verifikasi/${id}`,
                    method: "PUT",
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                    success: function (response) {
                        Swal.fire(
                            "Berhasil!",
                            "Akun telah diverifikasi.",
                            "success"
                        );
                        fetchAnak(); // Perbarui tabel setelah verifikasi
                    },
                    error: function (xhr) {
                        Swal.fire(
                            "Error!",
                            "Terjadi kesalahan saat verifikasi.",
                            "error"
                        );
                    },
                });
            }
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
                    fetchAnak(page, $("#search-input").val());
                }
            });
        }
    }

    $("#search-input").on("input", function () {
        searchQuery = $(this).val();
        fetchAnak(1, searchQuery);
    });

    fetchAnak(currentPage, searchQuery);
});
