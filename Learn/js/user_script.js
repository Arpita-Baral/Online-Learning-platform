// Profile toggle on user button click
// let profile=document.querySelector('.header .flex .profile');
// document.querySelector('#user-btn').onclick = () =>{
//     profile.classList.toggle('active');
//     searchForm.classList.remove('active');
// };
// let searchForm=document.querySelector('.header .flex .search-form');
// document.querySelector('#search-btn').onclick = () =>{
//     searchForm.classList.toggle('active');
//     profile.classList.remove('active');

// }
// let navbar=document.querySelector('.header .flex .navbar');
// document.querySelector('#menu-btn').onclick = () =>{
//     navbar.classList.toggle('active');
   
// };
// Profile dropdown
// // Profile dropdown
let profile = document.querySelector('.header .profile');
let searchForm = document.querySelector('.header .search-form');
let navbar = document.querySelector('.header .navbar');

// User button toggle (profile)
document.querySelector('#user-btn').onclick = (event) => {
    event.stopPropagation(); // Stop event from bubbling up
    profile.classList.toggle('active');
    searchForm.classList.remove('active');
    navbar.classList.remove('active');
};

// Search button toggle (search form)
document.querySelector('#search-btn').onclick = (event) => {
    event.stopPropagation(); // Stop event from bubbling up
    searchForm.classList.toggle('active');
    profile.classList.remove('active');
    navbar.classList.remove('active');
};

// Menu button toggle (navbar)
document.querySelector('#menu-btn').onclick = (event) => {
    event.stopPropagation(); // Stop event from bubbling up
    navbar.classList.toggle('active');
    profile.classList.remove('active');
    searchForm.classList.remove('active');
};

// Close all dropdowns when clicking outside
window.onclick = (event) => {
    if (!event.target.closest('.header')) {
        profile.classList.remove('active');
        searchForm.classList.remove('active');
        navbar.classList.remove('active');
    }
};
document.getElementById("toggle").addEventListener('click',function(){
    const pswd=document.getElementById('pswd');
    const ispswd=pswd.type==='pswd';
    pswd.type=ispswd?'text':pswd;
    this.textContent=ispswd?'hide':'show';
});