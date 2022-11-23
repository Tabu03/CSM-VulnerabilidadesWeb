let addClient=document.getElementById("clientAdd")
let formulario=document.getElementById("formAddC")


const toggleMostrar=()=>{
    if(formulario.style.display!="none"){
        formulario.style.display="none"
    }else{
        formulario.style.display="block"
    }
}

addClient.addEventListener("click",toggleMostrar)
document.addEventListener("DOMContentLoaded",toggleMostrar)