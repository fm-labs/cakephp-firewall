<?php
$this->assign('title', __('Firewall'));
$this->assign('heading', false);
$this->set('toolbar_disabled', true);
//$this->set('breadcrumbs_disabled', true);
$this->set('breadcrumbs', false);

$panelUri = $this->Url->build(['controller' => 'Shieldon', 'action' => 'index']);
?>
<div class="_container-fluid">

    <div class="px-2 py-2 bg-dark text-end">
        <?php echo $this->Html->link('Open Shieldon Panel in new window',
            ['controller' => 'Shieldon', 'action' => 'index'],
            ['target' => '_blank', 'data-icon' => 'external-link']
        ); ?>
    </div>

    <div class="iframe-container">
        <?php echo $this->Html->tag('iframe', __('Iframe not supported'), [
            'src' => $panelUri,
            'border' => 0,
            'style' => 'width: 100%; height: 90vh;'
        ]); ?>
    </div>
</div>
