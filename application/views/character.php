
<div>
	<div style="float:left"><h1><?= $user_details['name'] ?></h1></div>
	<div style="float:right"><h1><a href="<?=base_url()?>grid">Grid</a></h1></div>
	<div style="clear:both;"></div>
</div>

<div>
	<form action="updateCharacter" method="post">
		<ul>
			<li>Lvl: <b><?= $user_details['c_lvl']?></b></li>
			<li>Str: <?= $user_details['c_str']?></li>
			<li>Bld: <?= $user_details['c_bld']?></li> 
			<li>Dex: <?= $user_details['c_dex']?></li> 
		</ul>
	</form>
</div>

<div>
<h2>Skill Tree</h2>
<? foreach($tree as $branch) { ?>
	<div>
	<ul>
		<? foreach($branch as $t) { ?>
			<li> <?= $t['name']?>: <em><?= $t['description']?></em> </li>
		<? } ?>	
	</ul>
	</div><? } ?>
</div>
<div>
	<h2> Sample Attacks </h2>
	<ul>
		<? foreach($atks as $a) { ?>
			<li> <? pre_print_r($a)?></li>
		<? } ?>	
	</ul></div>
<? pre_print_r($user_details)?>
<? //pre_print_r($tree)?>