<?php echo $this->Form->create('User', array('url' => "/admin/site/userApp/edit/{$this->data['User']['id']}")); ?>
	<!-- Settings -->
	<?php echo $this->Html->useTag('fieldsetstart', __t('Editing user: %s', $this->data['User']['username'])); ?>
		<?php echo $this->Form->input('status', array('type' => 'checkbox', 'label' => __t('Active'))); ?>
		<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>

		<?php
			echo $this->Form->input('name', 
				array(
					'required' => 'required',
					'type' => 'text',
					'label' => __t('Real name *'),
					'helpBlock' => __t('Your real name, it is used only for identification purposes. i.e: John Locke')
				)
			);

			echo $this->Form->input('username',
				array(
					'required' => 'required',
					'type' => 'text',
					'label' => __t('User name *'),
					'helpBlock' => __t('Nick used to login. Must be unique and alphanumeric.')
				)
			);

			echo $this->Form->input('avatar',
				array(
					'type' => 'hidden',
					'value' => ''
				)
			);
		?>
		<?php echo $this->Form->input('email', array('required' => 'required', 'type' => 'email', 'label' => __t('E-mail *'))); ?>
		<?php echo $this->Form->input('public_email', array('type' => 'hidden')); ?>
		<?php echo $this->Form->input('language', array('type' => 'hidden')); ?>
		<?php App::import('Lib', 'Locale.QALocale'); ?>
		<?php echo $this->Form->input('timezone', array('type' => 'hidden')); ?>
		<?php echo $this->Form->input('password', array('type' => 'password', 'label' => __t('New password'), 'value' => '')); ?>
		<?php echo $this->Form->input('password2', array('type' => 'password', 'label' => __t('Confirm password'), 'helpBlock' => __t('If you would like to change the password type a new one. Otherwise leave this blank.'))); ?>
		<?php echo $this->Form->input('Role.Role', array('type' => 'hidden')); ?>

		<?php foreach ($this->data['Field'] as $field): ?>
			<?php echo $this->Node->renderField($field, true); ?>
		<?php endforeach; ?>

	<?php echo $this->Html->useTag('fieldsetend'); ?>

	<!-- Submit -->
	<?php echo $this->Form->submit(__t('Update user')); ?>
<?php echo $this->Form->end(); ?>
