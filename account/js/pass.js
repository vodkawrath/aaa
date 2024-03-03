let form = document.querySelector('form');

form.addEventListener('submit', function(){
    event.preventDefault();

    document.querySelector('#error').classList.add('hidden');

    if(/^.{4,}$/.test(document.querySelector('#pwd').value)){
        form.submit();
    }

    document.querySelector('#error').classList.remove('hidden');
});