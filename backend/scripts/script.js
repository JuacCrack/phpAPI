

function sendData() {
  const method = $('#method').val();
  const nameTable = $('#nameTable').val();
  
  // Obtener el valor del campo 'id' si es necesario
  const id = (method === 'POST' || method === 'PUT' || method === 'DELETE') ? $('#id').val() : null;

  // Si el método es 'POST' o 'PUT', llamar a la función para comprimir y convertir a base64
  if (method === 'POST' || method === 'PUT') {
    const image = $('#image')[0].files[0];
    // Llamar a la función para comprimir y convertir a base64
    compressAndConvertToBase64(image, function(base64Image) {
      // Construir el objeto JSON final con los datos y el ID (si está presente)
      const jsonData = {
        table_name: nameTable,
        data: {
          id_category: $('#id_category').val(),
          name: $('#name').val(),
          description: $('#description').val(),
          variety: $('#variety').val(),
          garrison: $('#garrison').val(),
          quantity: $('#quantity').val(),
          drink: $('#drink').val(),
          price1: $('#price1').val(),
          price2: $('#price2').val(),
          image: base64Image,
          date: $('#date').val(),
        },
      };

      if (id) {
        jsonData.id = id;
      }

      // Enviar la solicitud AJAX con el objeto JSON actualizado
      sendAjaxRequest(method, jsonData);
    });
  } else {
    // Si el método es 'GET' o 'DELETE', enviar la solicitud AJAX sin el campo 'method'
    const jsonData = {
      table_name: nameTable,
    };

    if (id) {
      jsonData.id = id;
    }

    // Enviar la solicitud AJAX con el objeto JSON actualizado
    sendAjaxRequest(method, jsonData);
  }
}

// Llamada a la función para mostrar los campos adecuados al cargar la página
$(document).ready(function() {
  showFieldsByMethod($('#method').val());
});

// Llamada a la función para mostrar los campos adecuados al cambiar el método seleccionado
$('#method').change(function() {
  showFieldsByMethod($(this).val());
});


function sendAjaxRequest(method, jsonData) {
  console.log (jsonData);
  $.ajax({
    url: `backend/php/index.php?table=${jsonData.table_name}`,
    type: method,
    data: JSON.stringify(jsonData),
    contentType: 'application/json',
    success: function(response) {
      // Procesar la respuesta aquí y mostrarla en el div con id 'response'
      $('#response').html(JSON.stringify(response));
    },
    error: function(xhr, status, error) {
      // Manejar errores aquí y mostrarlos en el div con id 'response'
      const errorMessage = xhr.responseText;
      $('#response').html(`Error: ${errorMessage}`);
    }    
  });
}

  function compressAndConvertToBase64(file, callback) {
    var reader = new FileReader();
  
    // Cuando se haya cargado la imagen
    reader.onload = function(event) {
      var img = new Image();
  
      // Cuando se haya cargado la imagen en el objeto
      img.onload = function() {
        // Crear un canvas
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
  
        // Resto del código se mantiene igual...
        
        // Obtener la imagen en formato base64 del canvas
        var base64Image = canvas.toDataURL('image/jpeg', 0.7); // Puedes ajustar la calidad de compresión aquí
  
        // Llamar al callback con la imagen base64
        callback(base64Image);
        
        // Mostrar la imagen en la etiqueta img con id "preview-image"
        document.getElementById("preview-image").src = base64Image;
      }
  
      // Establecer la imagen en el objeto
      img.src = event.target.result;
    }
  
    // Leer el archivo como una URL de datos
    reader.readAsDataURL(file);
  }