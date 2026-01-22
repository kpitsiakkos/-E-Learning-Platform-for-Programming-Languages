// Select the button and user profile elements
const userButton = document.querySelector('#user-button');
const userProfile = document.querySelector('.user-profile');

// Add a click event listener to the button
userButton.addEventListener('click', () => {
    // Toggle the 'active' class on the user profile
    userProfile.classList.toggle('active');
});




// Select the button and user search form elements
let searchForm = document.querySelector('.header .flex .search-bar');

// When the button menu is clicked then
document.querySelector('#search-button').onclick = () => {
    searchForm.classList.toggle('active');
}

window.onscroll = () => {
    // Toggle the 'active' class on the user profile
    searchForm.classList.toggle('active');
}



// assigns the <body> element of the current document to a variable named body.
let body = document.body;
let dashboardOptions = document.querySelector('.dashboard-options');

// When the button menu is clicked then
document.querySelector('#menu-button').onclick = () => {
    // Toggle the 'active' class on the dashboard options
    dashboardOptions.classList.toggle('active');
    body.classList.toggle('active');
    
}

window.onscroll = () => {
    // Toggle the 'active' class on the dashboard options
    searchForm.classList.toggle('active');
}

function showUnavailableMessage(e) {
    e.preventDefault(); // Prevents navigating to a new page
    alert('Course is not available yet.');
}




