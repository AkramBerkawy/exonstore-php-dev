<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
            <td><input type="text" name="title" value="<?php echo $title; ?>" />
              <?php if ($error_title) { ?>
              <span class="error"><?php echo $error_title; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_code; ?></td>
            <td><input type="text" name="code" value="<?php echo $code; ?>" />
              <?php if ($error_code) { ?>
              <span class="error"><?php echo $error_code; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_symbol_left; ?></td>
            <td><input type="text" name="symbol_left" value="<?php echo $symbol_left; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_symbol_right; ?></td>
            <td><input type="text" name="symbol_right" value="<?php echo $symbol_right; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_decimal_place; ?></td>
            <td><input type="text" name="decimal_place" value="<?php echo $decimal_place; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_value; ?></td>
            <td><input type="text" name="value" value="<?php echo $value; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="status">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>