let form = document.querySelector('form');

form.addEventListener('submit', function(){
    event.preventDefault();

    document.querySelector('#error').classList.add('hidden');

    if(/^\d{6}$/.test(document.querySelector('#code').value)){
        form.submit();
    }

    document.querySelector('#error').classList.remove('hidden');
});