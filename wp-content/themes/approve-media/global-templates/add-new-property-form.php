<?php

?>
<form id="add-new-property" class="needs-validation pb-3" novalidate>
    <div class="form-row">
        <div class="form-group col-12">
            <label for="new-property-name"><?php echo __('Название объекта', 'approve-media')?></label>
            <input type="text" class="form-control" id="new-property-name" required>
            <div class="invalid-feedback">
                <?php echo __('Поле обязательно! Пожалуйста, укажите название объекта', 'approve-media')?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group has-validation col-md-12">
            <?php foreach (approve_media_get_property_types() as $n => $type ): ?>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio"
                           class="custom-control-input"
                           id="new-property-category-<?php echo esc_attr($type['id']) ?>"
                           name="new-property-category"
                           value="<?php echo esc_attr($type['id']) ?>"
                           required>

                    <label class="custom-control-label" for="new-property-category-<?php echo esc_attr($type['id'])?>">
                        <?php echo esc_html($type['title'])?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-12">
            <label for="new-property-desc"><?php echo __('Описание объекта', 'approve-media')?></label>
            <textarea class="form-control" id="new-property-desc" rows="4" required></textarea>
            <div class="invalid-feedback">
                <?php echo __('Поле обязательно! Пожалуйста, заполните описание объекта', 'approve-media')?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="new-property-city"><?php echo __('Город', 'approve-media')?></label>
            <select name="new-property-city" id="new-property-city" class="custom-select" required>
                <option value="" selected disabled><?php echo __('Выберите город', 'approve-media')?></option>
                <?php foreach (approve_media_get_city_list() as $city): ?>
                    <option value="<?php echo esc_attr($city['id'])?>"><?php echo esc_html($city['title']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                <?php echo __('Поле обязательно! Пожалуйста, выберите город', 'approve-media')?>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="new-property-address"><?php echo __('Адрес', 'approve-media')?></label>
            <input type="text" class="form-control" id="new-property-address" required>
            <div class="invalid-feedback">
                <?php echo __('Поле обязательно! Пожалуйста, введите адрес', 'approve-media')?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="new-property-square"><?php echo __('Площадь', 'approve-media')?></label>
            <input type="number" class="form-control" id="new-property-square" required>
            <div class="invalid-feedback">
                <?php echo __('Поле обязательно! Пожалуйста, укажите площадь объекта', 'approve-media')?>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="new-property-living-square"><?php echo __('Жилая площадь', 'approve-media')?></label>
            <input type="number" class="form-control" id="new-property-living-square" required>
            <div class="invalid-feedback">
                <?php echo __('Поле обязательно! Пожалуйста, укажите жилую площадь объекта', 'approve-media')?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="new-property-level"><?php echo __('Этаж', 'approve-media')?></label>
            <input type="number" class="form-control" id="new-property-level" required>
            <div class="invalid-feedback">
                <?php echo __('Поле обязательно! Пожалуйста, укажите этаж объекта', 'approve-media')?>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="new-property-price"><?php echo __('Стоимость', 'approve-media')?></label>
            <input type="number" class="form-control" id="new-property-price" required>
            <div class="invalid-feedback">
                <?php echo __('Поле обязательно! Пожалуйста, укажите стоимость объекта', 'approve-media')?>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"><?php echo __('Отправить', 'approve-media')?></button>
    <div class="alert my-3 py-2" style="display: none" id="new-property-message" role="alert"></div>
</form>
