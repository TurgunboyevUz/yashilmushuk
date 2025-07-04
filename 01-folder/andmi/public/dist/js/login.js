$(function () {
    $('#password_eye').on('click',function () {
        let password_eye = $('#fa-eye').attr('class');
        if (password_eye === "fas fa-eye"){
            $('#fa-eye').removeClass('fa-eye').addClass('fa-eye-slash');
            $('#password').attr('type','text');
        }else{
            $('#fa-eye').removeClass('fa-eye-slash').addClass('fa-eye');
            $('#password').attr('type','password');
        }
    });

    $('#password_eye2').on('click',function () {
        let password_eye2 = $('#fa-eye2').attr('class');
        if (password_eye2 === "fas fa-eye"){
            $('#fa-eye2').removeClass('fa-eye').addClass('fa-eye-slash');
            $('#password_confirmation').attr('type','text');
        }else{
            $('#fa-eye2').removeClass('fa-eye-slash').addClass('fa-eye');
            $('#password_confirmation').attr('type','password');
        }
    });

    $('#password_eye3').on('click',function () {
        let password_eye3 = $('#password_eye3').attr('class');
        if (password_eye3 === "fas fa-eye"){
            $('#password_eye3').removeClass('fa-eye').addClass('fa-eye-slash');
            $('#password').attr('type','text');
        }else{
            $('#password_eye3').removeClass('fa-eye-slash').addClass('fa-eye');
            $('#password').attr('type','password');
        }
    });
});