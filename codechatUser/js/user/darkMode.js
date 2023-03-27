function switchColorMode(){
    const html = document.getElementsByTagName("html")[0];
    const buttons = document.getElementsByClassName("colorModeButton");

    const isInDarkMode = html.getAttribute("data-bs-theme") === "dark";
    const wantedMode = isInDarkMode ? 'light' : 'dark';
    const notWantedMode = isInDarkMode ? 'dark' : 'light';

    //change current page html
    html.setAttribute("data-bs-theme", wantedMode);
    for (const button of buttons)
        button.textContent = notWantedMode + " mode";

    //store cookie
    let expires = (new Date(Date.now() + 1000 * 3600 * 24 * 300)).toUTCString();
    document.cookie = 'codechat_theme=' + wantedMode + ';expires=' + expires + ';path=/';
}

