<?php 

//response generation function
$response = "";

//function to generate response
function my_contact_form_generate_response($type, $message){

	global $response;

	if($type == "success") $response = "<div class='success'>{$message}</div>";
	else $response = "<div class='error'>{$message}</div>";

}

get_header(); ?>
<br>
<?php 
if (isset($_POST['asunto'])) {
	$mensaje="<strong>Remitente: </strong>".$_POST['correo']."<br>".
			 "<strong>Website: </strong>".$_POST['website']."<br>".
			 "<strong>Nombre: </strong>".$_POST['nombre']."<br>".
			 "<strong>Asunto: </strong>".$_POST['asunto']."<br>".
			 "<strong>Mensaje: </strong><br>".strip_tags($_POST['mensaje'])."<br>";
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$headers[] = 'From: '. $_POST['correo'];
	
	$sent = wp_mail('info@ccjpv.com', $_POST['asunto'], $mensaje, $headers);
	
	if($sent) my_contact_form_generate_response("success", "El mensaje ha sido enviado"); //message sent!
	else my_contact_form_generate_response("error", "Error en el servidor de correo"); //message wasn't sent
	
?>
	<div class="ui container">
		<div class="ui center aligned segment" style="min-height: 500px">
			<h2 class="ui header">Envio correcto</h2>
			<p><i class="ui big circular red inverted mail icon"></i></p>
			<p>Gracias por contactarse con nosotros, su mensaje fue enviado correctamente, nos pondremos en contacto con usted a la brevedad posible.</p>
		</div>
	</div>
<?php 
}else{
?>
<div class="ui container">
	<div class="ui segment">
		<h1 class="ui dividing header">Contacto</h1>
		<div class="ui two column grid">
			<div class="column">
				<form class="ui form" method="post">
				  <div class="required field">
				    <label>Nombre</label>
				    <input type="text" id="nombre" name="nombre" placeholder="Pablo Pérez">
				  </div>
				  <div class="required field">
				    <label>Email</label>
				    <input type="text" id="correo" name="correo" placeholder="yo@dominio.com">
				  </div>
				  <div class="required field">
				    <label>Asunto</label>
				    <input type="text" id="asunto" name="asunto" placeholder="Asunto">
				  </div>
				  <div class="required field">
				    <label>Mensaje</label>
				    <textarea rows="4" cols="20" id="mensaje" name="mensaje"></textarea>
				  </div>
				  <input class="ui red button" type="submit" value="Enviar">
				  <div class="ui error message"></div>
				</form>
			</div>
			<div class="column">
				<br><p>Mediante el siguiente formulario podrá enviarnos cualquier comentario o solicitud de información. Le responderemos a la brevedad posible.</p>
				
				<h3 class="ui header">Horarios de atención</h3>
				<p>Los horarios y los espacios de atención son pensados en personas que trabajan y que tienen responsabilidades del cuidado de la familia.</p>
				<p>Martes, miércoles, jueves, viernes 9h00 a 18h00 y Sábado de 9h00 a 14h00</p>
				<br>
				<p><strong>Dirección:<br></strong>Tomás de Berlanga E10-115 e Isla Pinzón (esquina).<br>Quito – Ecuador</p>
				<p><i class="circular inverted phone icon"></i> (593 2) 2453-585</p>
				<p><a href="mailto:info@ccjpv.com"><i class="circular inverted mail icon"></i>info@ccjpv.com</a></p>
				<iframe src="https://www.google.com/maps/d/u/0/embed?mid=1AOAWaSICL-KVKHO__ZkXIi_fRp4" width="100%" height="400"></iframe>
				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$('.ui.form')
.form({
  fields: {
    nombre: {
      identifier: 'nombre',
      rules: [
        {
          type   : 'empty',
          prompt : 'Por favor, ingrese un nombre'
        }
      ]
    },
    correo: {
        identifier: 'correo',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor, ingrese el email'
          },
          {
            type   : 'email',
            prompt : 'Por favor, ingrese una dirección válida de email'
          }
        ]
      },
   asunto: {
      identifier: 'asunto',
      rules: [
        {
          type   : 'empty',
          prompt : 'Por favor, ingrese un asunto'
        }
      ]
    },
    mensaje: {
      identifier: 'mensaje',
      rules: [
        {
          type   : 'empty',
          prompt : 'Por favor, ingrese un mensaje'
        }
      ]
    }
  }
})
;
</script>
<?php }?>
<?php get_footer(); ?>