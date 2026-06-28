'use strict';

const resetForm =
document.getElementById(
    'resetPasswordForm'
);

resetForm.addEventListener(
    'submit',
    async (e) => {

        e.preventDefault();

        const email =
        document.getElementById('email').value;

        try {

            const response =
            await fetch(
                'http://localhost:5000/api/forgot-user',
                {
                    method: 'POST',

                    headers: {
                        'Content-Type':
                        'application/json'
                    },

                    body: JSON.stringify({
                        email
                    })
                }
            );

            const data =
            await response.json();

            if (response.ok){

                alert(
                    'Reset password berhasil dibuat'
                );

                console.log(
                    'TOKEN RESET:',
                    data.token
                );
            }

            else{

                alert(data.message);
            }
        }

        catch(error){

            console.log(error);

            alert('Server error');
        }
    }
);