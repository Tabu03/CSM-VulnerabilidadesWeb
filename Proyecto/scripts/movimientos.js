let addClient=document.getElementById("clientAdd")
let deleteClient=document.getElementById("deleteClient")
let modifyBalance=document.getElementById("modifyBalance")
let formAddC=document.getElementById("formAddC")
let formDel=document.getElementById("formDel")
let formMod=document.getElementById("formMod")

formAddC.style.display="none"
formDel.style.display="none"
formMod.style.display="none"
// formAddC.style.display="none"
const toggleMostrar=(event)=>{
    elemento = event.target
    if(elemento==addClient){
        if(formDel.style.display!="none"){
            formDel.style.display="none"
        }
        if(formMod.style.display!="none"){
            formMod.style.display="none"
        }
        if(formAddC.style.display!="none"){
            formAddC.style.display="none"
        }else{
            formAddC.style.display="flex"
        }
    }
    if(elemento==deleteClient){
        if(formAddC.style.display!="none"){
            formAddC.style.display="none"
        }
        if(formMod.style.display!="none"){
            formMod.style.display="none"
        }
        if(formDel.style.display!="none"){
            formDel.style.display="none"
        }else{
            formDel.style.display="flex"
        }
    }
    if(elemento==modifyBalance){
        if(formAddC.style.display!="none"){
            formAddC.style.display="none"
        }
        if(formDel.style.display!="none"){
            formDel.style.display="none"
        }
        if(formMod.style.display!="none"){
            formMod.style.display="none"
        }else{
            formMod.style.display="flex"
        }
    }
    
    
}



document.addEventListener("click",toggleMostrar)
document.addEventListener("DOMContentLoaded",toggleMostrar)