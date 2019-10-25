/*
/!*document.querySelector('.item').addEventListener('mouseenter',()=>{
    document.querySelector('.item').style.transform = "translate(0px,5px)";
});*!/
document.querySelector('.item').addEventListener('mouseleave',()=>{
    document.querySelector('.item').style.transform = "translate(0px,0px)";
});
*/

document.querySelectorAll('.item').forEach(value => {
   value.addEventListener('mouseenter',()=>{
        value.style.transform = "translate(8px,0px)";
     //  value.classList.add('animation');
     // value.style.transform = "rotateX(90deg)";
       value.addEventListener('mouseleave',()=>{
          // value.classList.remove('animation');
           value.style.transform = "translate(0px,0px)";
       });
})});