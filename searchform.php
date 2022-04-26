<?php 

$action = home_url('/');
$label  = __('Search');
$query  = get_search_query();

?>
<form action="<?= $action ?>" method="get" class="form-inline">
    <fieldset>
      <div class="input-group">
        <input type="text" name="s" id="search" placeholder="<?= $label ?>" value="<?= $query ?>" class="form-control" />
        <span class="input-group-append">
          <button type="submit" class="btn btn-primary"><?= $label ?></button>
        </span>
      </div>
    </fieldset>
</form>