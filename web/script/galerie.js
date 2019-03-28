(function() {
    Ajax.get("./services/picture").then(function(response) {
        var response = JSON.parse(response),
            data = [];
        
        for (var i = 0; i < response.length; i++) {
            var object = {
                minUrl: 'imgs/uploads/min/'+response[i].sha+response[i].extension,
                url: 'imgs/uploads/'+response[i].sha+response[i].extension,
                alt: response[i].title,
                resum: {title: response[i].title, content: response[i].resum}
            };

            data.push(object);
        }
        
        var container = document.getElementsByClassName('thumbs')[0];
        galerie = new Galerie(data, container, 'La galerie');

        galerie.load();
    });
})();