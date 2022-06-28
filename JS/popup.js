
popup = document.getElementById('popup')
popup_name = document.getElementById('popup-name')
popup_description = document.getElementById('popup-description')



function showOverlay(name, description){
    
    if(popup.className == "unhide"){
        popup.className = "hide";
    }else{
        popup.className = "unhide";
    }
    console.log(name);
    console.log(description);

    popup_name.innerHTML = name;
    popup_description.innerHTML = description;

}

function download(){
    print();
}