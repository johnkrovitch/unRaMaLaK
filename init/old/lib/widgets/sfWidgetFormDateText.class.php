<?php

/**
 * 
 *
 * This widget needs :
 * - JQuery
 * - JQuery UI
 * - JQuery Masked Input plugin http://digitalbush.com/projects/masked-input-plugin/.
 *
 * @package    wafSinistresPlugin
 * @subpackage widget
 * @author     xgodart
 */
class sfWidgetFormDateText extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
    // On s'assure que le helper est bien chargé.
    sfApplicationConfiguration::getActive()->loadHelpers('Asset');
    
    $this->addOption('php_date_format', 'd/m/Y');
    $this->addOption('image', image_path('date.png'));
    $this->addOption('changeMonth', true);
    $this->addOption('changeYear', true);
    $this->addOption('yearRange', false);
    $this->addOption('config', '{}');
    $this->addOption('culture', 'fr');
    $this->addOption('labels', array('date' => '<span>le&nbsp;</span>', 'time' => '<span class="heure">&nbsp;à</span>', 'hours' => ':'));
    $this->addOption('add_time', false);
    $this->addOption('date_format', 'yy-mm-dd');
    $this->addOption('date_size', 9);
    $this->addOption('use_mask', true);
    
    parent::configure($options, $attributes);
    
    if ('en' == $this->getOption('culture'))
    {
      $this->setOption('culture', 'en');
    }
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $attributes = array_merge($this->attributes, $attributes);
    $prefix = $this->generateId($name);
    $labels = $this->getOption('labels');
    
    $php_date_format = $this->getOption('php_date_format');
    $dateSize = $this->getOption('date_size');

    // Si la value est une chaîne, on la découpe
    if (!is_array($value) && $value)
    {
      if (is_numeric($value))
      {
        $date = $value;
      }
      else
      {
        $date = strtotime($value);
      }
      $value = array();
      $value['date'] = date($php_date_format, $date);
      $value['time'] = date('H:i', $date);
    }
    $image = '';
    if (false !== $this->getOption('image'))
    {
      $image = sprintf(', buttonImage: "%s", buttonImageOnly: true', $this->getOption('image'));
    }

    $yearRange = '';
    if (false !== $this->getOption('yearRange'))
    {
      $yearRange = sprintf(', yearRange: "%s"', $this->getOption('yearRange'));
    }
    $output = $labels['date'].$this->renderInputWidget($name.'[date]', $value['date'], array(),  array_merge(array('size' => $dateSize), $attributes));
    if ($this->getOption('add_time'))
    {
      $output .= $labels['time'].$this->renderInputWidget($name.'[time]', $value['time'], array(), array('size' => 3, 'class' => 'heure'));
    }
    
    if($this->getOption('use_mask')){
      $output .= $this->renderTag('input', array('type' => 'hidden', 'size' => 10, 'id' => $id = $this->generateId($name).'_jquery_control', 'disabled' => 'disabled')).
           sprintf(<<<EOF
<script type="text/javascript">
  function wfd_%s_read_linked(dateText, inst)
  {
    jQuery("#%s").val(jQuery("#%s").val());

    return {};
  }

  function wfd_%s_update_linked(date, picker)
  {
    jQuery("#%s").val(date).change();
  }

  jQuery(document).ready(function() {
    jQuery("#%s").mask("99/99/9999");
    jQuery("#%s").mask("99%s99");
    jQuery("#%s").datepicker(jQuery.extend({}, {
      beforeShow: wfd_%s_read_linked,
      onSelect:   wfd_%s_update_linked,
      showOn:     "button",
      showMonthAfterYear: false,
      changeYear: %s,
      changeMonth: %s
      %s
      %s
    }, jQuery.datepicker.regional["%s"], %s, {dateFormat: "%s"}));
  });
</script>
EOF
      ,
      $prefix, $id,
      $this->generateId($name.'[date]'),
      $prefix,
      $this->generateId($name.'[date]'),
      $this->generateId($name.'[date]'),
      $this->generateId($name.'[time]'), $labels['hours'],
      $id,
      $prefix, $prefix, $this->getOption('changeYear'), $this->getOption('changeMonth'), $image, $yearRange,
      $this->getOption('culture'), $this->getOption('config'), $this->getOption('date_format')
    );
    }else{
     $output .= $this->renderTag('input', array('type' => 'hidden', 'size' => 10, 'id' => $id = $this->generateId($name).'_jquery_control', 'disabled' => 'disabled')).
           sprintf(<<<EOF
<script type="text/javascript">
  function wfd_%s_read_linked(dateText, inst)
  {
    jQuery("#%s").val(jQuery("#%s").val());

    return {};
  }

  function wfd_%s_update_linked(date, picker)
  {
    jQuery("#%s").val(date).change();
  }

  jQuery(document).ready(function() {    
    jQuery("#%s").datepicker(jQuery.extend({}, {
      beforeShow: wfd_%s_read_linked,
      onSelect:   wfd_%s_update_linked,
      showOn:     "button",
      showMonthAfterYear: false,
      changeYear: %s,
      changeMonth: %s
      %s
      %s
    }, jQuery.datepicker.regional["%s"], %s, {dateFormat: "%s"}));
  });
</script>
EOF
      ,
      $prefix, $id,
      $this->generateId($name.'[date]'),
      $prefix,
      $this->generateId($name.'[date]'),         
      $id,
      $prefix, $prefix, $this->getOption('changeYear'), $this->getOption('changeMonth'), $image, $yearRange,
      $this->getOption('culture'), $this->getOption('config'), $this->getOption('date_format')
    );
    }

    return $output;
  }

  /**
   *
   * @param string $name
   * @param string $value
   * @param array $options
   * @param array $attributes
   * @return string rendered HTML
   */
  protected function renderInputWidget($name, $value, $options = array(), $attributes = array())
  {
    $widget = new sfWidgetFormInputText($options, $attributes);
    return $widget->render($name, $value);
  }
}
