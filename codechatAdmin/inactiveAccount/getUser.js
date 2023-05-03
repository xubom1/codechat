document.getElementById('dateSince').valueAsDate = new Date();

async function getInactiveUser(){
    const inputDate = document.getElementById('dateSince').value;
    const inputNumber = document.getElementById('showNumber').value;
    try {
        const res = await fetch('getUser.php?date=' + inputDate + '&number=' + inputNumber);
        const str = await res.text();
        if (str) {
            const problem = document.getElementById('description');
            problem.innerHTML = 'Found succefully !';
            problem.classList.value = "alert alert-success mt-4";
            const user = document.getElementById('userRow');
            user.innerHTML = str;
        } else {
            const problem = document.getElementById('description');
            problem.innerHTML = 'Not found !';
            problem.classList.value = "alert alert-danger mt-4";
            const user = document.getElementById('userRow');
            user.innerHTML = ' ';
        }
    } catch (err) {
        alert('bug');
    }
}