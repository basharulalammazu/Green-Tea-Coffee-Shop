const wrapper = document.querySelector('.wrapper')
const registerLink = document.querySelector('.register-link')
const loginLink = document.querySelector('.login-link')

registerLink.onclick = () => {
    wrapper.classList.add('active')
}

loginLink.onclick = () => {
    wrapper.classList.remove('active')
}

function showPopup(message) {
        document.getElementById("popup-message").innerText = message;
        document.getElementById("popup").classList.remove("hidden");
}

function hidePopup() {
        document.getElementById("popup").classList.add("hidden");
}

