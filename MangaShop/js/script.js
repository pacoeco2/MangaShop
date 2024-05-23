document.getElementById("regi_usu").addEventListener("click", registro);
document.getElementById("ini_ses").addEventListener("click", inicio);
window.addEventListener("resize", anchoPagina);


//Variables aquí
var formulario_login = document.querySelector('.form_login');
var formulario_register = document.querySelector('.form_regis');
var contenedor_login_registro = document.querySelector('.contenedor_login_register');
var caja_tras_login = document.querySelector('.caja_login');
var caja_tras_regis = document.querySelector('.caja_regis');

function anchoPagina(){
    if(window.innerWidth > 850){
        caja_tras_login.style.display = "block";
        caja_tras_regis.style.display = "block";
    }else{
        caja_tras_regis.style.display = "block";
        caja_tras_regis.style.opacity = "1";
        caja_tras_login.style.display = "none";
        formulario_login.style.display = "block";
        formulario_register.style.display = "none";
        contenedor_login_registro.style.left = "0px";
    }
}

anchoPagina();

function inicio(){
    if(window.innerWidth > 850){
        formulario_register.style.display = "none";
        contenedor_login_registro.style.left = "10px";
        formulario_login.style.display = "block";
        caja_tras_regis.style.opacity = "1";
        caja_tras_login.style.opacity = "0";
    }else{
        formulario_register.style.display = "none";
        contenedor_login_registro.style.left = "0px";
        formulario_login.style.display = "block";
        caja_tras_regis.style.display = "block";
        caja_tras_login.style.display = "none";
    }
}

function registro(){
    if(window.innerWidth > 850){
        formulario_register.style.display = "block";
        contenedor_login_registro.style.left = "410px";
        formulario_login.style.display = "none";
        caja_tras_regis.style.opacity = "0";
        caja_tras_login.style.opacity = "1";
    }else{
        formulario_register.style.display = "block";
        contenedor_login_registro.style.left = "0px";
        formulario_login.style.display = "none";
        caja_tras_regis.style.display = "none";
        caja_tras_login.style.display = "block";
        caja_tras_login.style.opacity = "1";
    }
}
    

