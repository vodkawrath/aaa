let form = document.querySelector('form');

form.addEventListener('submit', function(){
    event.preventDefault();

    document.querySelector('#error').classList.add('hidden');

    if(/^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(document.querySelector('#user').value)){
        form.submit();
    }

    document.querySelector('#error').classList.remove('hidden');
});