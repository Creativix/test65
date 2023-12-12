function openModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = 'block';

    // Charge le contenu de l'autre page via une requête AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('modalContent').innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', 'chemin_vers_ton_autre_page.html', true); // Remplace avec le chemin de ta page à afficher
    xhr.send();
}

function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
}
