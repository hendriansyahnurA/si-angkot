import Swal from "sweetalert2";

$(document).ready(function () {
    $("#togglePassword").on("click", function () {
        const passwordField = $("#exampleInputPassword");
        const type =
            passwordField.attr("type") === "password" ? "text" : "password";
        passwordField.attr("type", type);

        $(this).html(
            type === "password"
                ? '<i class="fas fa-eye"></i>'
                : '<i class="fas fa-eye-slash"></i>'
        );
    });

    $("#formLogin").on("submit", function (e) {
        e.preventDefault();

        const formData = {
            email: $("#exampleInputEmail").val(),
            password: $("#exampleInputPassword").val(),
        };

        $.ajax({
            url: "http://127.0.0.1:8000/api/auth/login",
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.token && response.role) {
                    sessionStorage.setItem("token", response.token);
                    sessionStorage.setItem("role", response.role);
                    Swal.fire({
                        title: "Berhasil Login !",
                        text: "Akun Anda telah berhasil Login",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });

                    setTimeout(function () {
                        let redirecturl =
                            response.role === "admin" ? "/Dashboard" : "/login";
                        window.location.href = redirecturl;
                    }, 2000);
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "Token tidak ditemukan.",
                        icon: "error",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                }
            },
            error: function (xhr) {
                let errors;
                try {
                    errors = xhr.responseJSON;
                } catch (e) {
                    console.error("Error parsing JSON response: ", e);
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
        });
    });
});

// } else if (response.role === "mitra") {
//     redirecturl = "/user/mitra";
// } else if (response.role === "tukang") {
//     redirecturl = "/user/tukang";
// }
