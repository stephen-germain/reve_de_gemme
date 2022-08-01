window.onload=function(){
    
    var buttonScrollTop = document.getElementById('buttonScrollTop');
   
    buttonScrollTop.addEventListener('click', function(){
        window.scroll({ top: 0, behavior:'smooth'});
    });

    window.onscroll = function() {
        scrollfunction();
    }

    function scrollfunction(){
        if (document.body.scrollTop > 350 || document.documentElement.scrollTop > 350){
            buttonScrollTop.classList.add("buttonActive");
        }
        else{
            buttonScrollTop.classList.remove("buttonActive");
        }
    }
}
