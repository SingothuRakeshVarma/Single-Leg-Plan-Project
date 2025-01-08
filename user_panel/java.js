
     const signInForm2 = document.getElementById('signInForm2');
    const signUpForm2 = document.getElementById('signUpForm2');
    const signUpLink2 = document.getElementById('signUpLink2');
    const signInLink2 = document.getElementById('signInLink2');
    const signForm2 = document.getElementById('signForm2');
    const signLink2 = document.getElementById('signLink2');
    const signForm21 = document.getElementById('signForm21');
    const signLink21 = document.getElementById('signLink21');

    signUpLink2.addEventListener('click', function(event) {
        event.preventDefault();
        signInForm2.style.display = 'none';
        signUpForm2.style.display = 'block';
        signForm2.style.display = 'none';
        signForm21.style.display = 'none';
        signInLink2.style.backgroundColor = 'transparent';
        signLink2.style.backgroundColor = 'transparent';
        signLink21.style.backgroundColor = 'transparent';
        signUpLink2.style.backgroundColor = 'darkcyan';
    });

    signInLink2.addEventListener('click', function(event) {
        event.preventDefault();
        signInForm2.style.display = 'block';
        signForm2.style.display = 'none';
        signUpForm2.style.display = 'none';
        signForm21.style.display = 'none';
        signUpLink2.style.backgroundColor = 'transparent';
        signLink2.style.backgroundColor = 'transparent';
        signLink21.style.backgroundColor = 'transparent';
        signInLink2.style.backgroundColor = 'darkcyan';
    });

    signLink2.addEventListener('click', function(event) {
        event.preventDefault();
        signInForm2.style.display = 'none';
        signUpForm2.style.display = 'none';
        signForm21.style.display = 'none';
        signForm2.style.display = 'block';
        signUpLink2.style.backgroundColor = 'transparent';
        signInLink2.style.backgroundColor = 'transparent';
        signLink21.style.backgroundColor = 'transparent';
        signLink2.style.backgroundColor = 'darkcyan';
    });

    signLink21.addEventListener('click', function(event) {
        event.preventDefault();
        signInForm2.style.display = 'none';
        signUpForm2.style.display = 'none';
        signForm2.style.display = 'none';
        signForm21.style.display = 'block';
        signUpLink2.style.backgroundColor = 'transparent';
        signInLink2.style.backgroundColor = 'transparent';
        signLink2.style.backgroundColor = 'transparent';
        signLink21.style.backgroundColor = 'darkcyan';
    });

