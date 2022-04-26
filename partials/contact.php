<?php 

$contact = element($_POST, 'contact');

$to = wpt_setting('contact_to');
$from = wpt_setting('contact_from');

if( ! empty($contact) && !! element($contact, 'submit') )
{
  $contact['name']    = sanitize_text_field( element($contact,'name','') );
  $contact['phone']   = sanitize_text_field( element($contact,'phone','') );
  $contact['email']   = sanitize_email( element($contact,'email','') );
  $contact['choice']  = element($contact,'choice');
  $contact['message'] = sanitize_textarea_field( element($contact,'message','') );
  $contact['name']    = sanitize_text_field( element($contact,'name','') );
  $contact['agree']   = isset($contact['agree']);
  $contact['check']   = isset($contact['check']);

  $error = '';
  $success = '';

  if( empty($to) )
  {
    $error = 'Destination mail not set';
  }

  if( !! $contact['check'] OR ! wp_verify_nonce( sanitize_text_field(element($contact, 'nonce', '')), 'contact' ) )
  {
    $error = 'There was an error submitting your form. Try again later';
  }

  foreach( array('name','email','message') as $field )
  {
    if( empty($contact[$field]) )
    {
      $error = ucfirst($field) . ' is required';
    }
  }


  if( empty($error) )
  {
    $subject = site_url() . ': New message from ' . $contact['name'];

    $headers = ! empty($from) ? 'From: ' . $from : '';

    if( wp_mail($to, $subject, $contact['message']) )
    {
      $success = 'Message sent! We will respond to your email shortly.';
    }
    else
    {
      $error = 'Message could not be sent! Please contact the website owner. (not with this form, obviously)';
    }


  }

}

?>







<form class="contact-form" action="<?= current_url() ?>" method="post">
  <div class="row">

  <?php if( ! empty($success) ) { ?>
  <div class="col-lg-12">
    <div class="alert alert-success" role="alert">
      <?= $success ?>
    </div>
  </div>
  <?php } else { ?>

  <?php if( ! empty($error) ) { ?>
  <div class="col-lg-12">
    <div class="alert alert-danger" role="alert">
      <?= $error ?>
    </div>
  </div>
  <?php } ?>


  <div class="col-lg-6">

    <div class="form-group">
      <label for="contact-name">Your Name</label>
      <input id="contact-name" name="contact[name]" type="text" class="form-control" value="<?= element($contact, 'name','');?>" required />
    </div>

    <div class="form-group">
      <label for="contact-phone">Your Phone</label>
      <input id="contact-phone" name="contact[phone]" type="text" class="form-control" value="<?= element($contact, 'phone','');?>" />
    </div>
    
    <div class="form-group">
      <label for="contact-email">Your Email</label>
      <input id="contact-email" name="contact[email]" type="email" class="form-control" value="<?= element($contact, 'email','');?>" required />
    </div>
  
    <div class="form-group">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="contact[choice]" id="contact-choice-1" value="one" <?= element($contact,'choice') == 'one' ? 'checked' : ''?>>
        <label class="form-check-label" for="contact-choice-1">One</label>
      </div>
      
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="contact[choice]" id="contact-choice-2" value="two" <?= element($contact,'choice') == 'two' ? 'checked' : ''?>>
        <label class="form-check-label" for="contact-choice-2">Two</label>
      </div>
    </div>

    

    

  </div>


  <div class="col-lg-6">
    
    <div class="form-group">
      <label for="contact-message">Your Message</label>
      <textarea id="contact-message" name="contact[message]" class="form-control"><?= element($contact, 'message','') ?></textarea>
    </div>

    <div class="form-group">
      
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="contact-agree" name="contact[agree]" <?= element($contact,'agree') == '1' ? 'checked' : ''?>>
        <label class="form-check-label" for="contact-agree">
          Check this out
        </label>
      </div>
    </div>


    <div class="form-group">
      <input type="checkbox" id="contact-check" name="contact[check]" value="1" />
      <input type="hidden" name="contact[nonce]" value="<?= wp_create_nonce('contact') ?>" />
      <button class="btn btn-primary btn-block" type="submit" id="contact-submit" name="contact[submit]" value="1">
        Send Email
      </button>
    </div>
  </div>
  
  <?php } ?>
  </div>

</form>