let Ing=document.getElementById("Ing")
let Sac=document.getElementById("Sac")
let Com=document.getElementById("Com")
let formIng=document.getElementById("formIng")
let formSac=document.getElementById("formSac")

formIng.style.display="none"
formSac.style.display="none"
const toggleMostrar=(event)=>{
    elemento = event.target
    if(elemento==Ing){
        if(formSac.style.display!="none"){
            formSac.style.display="none"
        }
        if(formIng.style.display!="none"){
            formIng.style.display="none"
        }else{
            formIng.style.display="flex"
        }
    }
    if(elemento==Sac){
        if(formIng.style.display!="none"){
            formIng.style.display="none"
        }
        if(formSac.style.display!="none"){
            formSac.style.display="none"
        }else{
            formSac.style.display="flex"
        }
    }
    
    
    
}




document.addEventListener("click",toggleMostrar)
document.addEventListener("DOMContentLoaded",toggleMostrar)