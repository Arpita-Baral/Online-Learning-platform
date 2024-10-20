let body=document.body;
document.querySelector('#user-btn').onclick = () => {
document.querySelector('.header .profile').classList.toggle('active');//cht gpt line 2 and 3
  };
let profile=document.querySelector('header .flex .profile');
document.querySelector('#user-btn').onclick = () =>{
    profile.classList.toggle('active');
    searchForm.classList.remove('active');
};
let searchForm=document.querySelector('#search-btn').onclick = () =>{
    searchForm.classList.toggle('active');
    profile.classList.remove('active');
};
let sideBar=document.querySelector('.side-bar');
document.querySelector('#menu-btn').onclick = ()=>{
    sideBar.classList.toggle('active');
    ReportBody.classList.toggle('active');
};
window.onscroll = () => {
   profile.classList.remove('active');
   searchForm.classList.remove('active');
   
 if(window.innerWidth<1200){
    sideBar.classList.remove('active');
    body.classList.remove('active');
}};

// (() => {
//     const counter = document.querySelectorAll(' .counter'); //convert to array
//     const array = Array. from (counter);
//     //select array element array.map((item) =>{ //data layer
//     let counterInnerText = item.textContent; item.textContent = 0; 
//     let count = 1;
//     let speed= item.dataset.speed/ counterInnerText;
//      function counterUp() {
//     item.textContent = count++;
//     if (counterInnerText < count)
//          { clearInterval (stop);
//     }
//     }
//     const stop = setInterval(() => {
//     counterUp();
//     }, speed)
// })


