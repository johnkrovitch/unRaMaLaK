<div id="login">

  <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
    <table>
      <tbody>
        <?php echo $form ?>
        <tr>
          <td colspan="2"><?php echo link_to('Nouveau joueur ?', '@new_player') ?></td>
        </tr>
      </tbody>
    </table>

    <input type="submit" value="<?php echo __('Signin', null, 'sf_guard') ?>" />

    <a href="<?php //echo url_for('@sf_guard_forgot_password') ?>" class="forgot-password"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
    <a href="<?php //echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?', null, 'sf_guard') ?></a>
  </form>
  
</div>