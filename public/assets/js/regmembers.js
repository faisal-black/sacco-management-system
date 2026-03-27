document.addEventListener('DOMContentLoaded', () => {

    const registerForm = document.getElementById('registerForm');

    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(registerForm);

        try {
            const response = await fetch('/sacco-management-system/app/controllers/RegMemberController.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                registerForm.reset();
            } else {
                alert("Errors:\n" + result.errors.join("\n"));
            }

        } catch (error) {
            console.error(error);
            alert("Something went wrong");
        }
    });

});