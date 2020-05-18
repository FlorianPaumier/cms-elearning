<section style="display: none">
    <ul class="input-skeleton" draggable="true" data-id="__INDEX__" data-target="__INDEX__">
        <li>
            <label for="admin_contact[__INDEX__][type_input]"></label>
            <select name="admin_contact[__INDEX__][type_input]" id="admin_contact[__INDEX__][type_input]">
                <option value="text">Text</option>
                <option value="textarea">Textarea</option>
                <option value="checkbox">Checkbox</option>
                <option value="email">Email</option>
                <option value="phone">Phone</option>
                <option value="address">Address</option>
                <option value="captcha">Captcha</option>
                <option value="date">Date</option>
                <option value="submit">Submit</option>
            </select>
        </li>
        <li>
            <label for="admin_contact[__INDEX__][label_input]">Label</label>
            <input type="text" id="admin_contact[__INDEX__][label_input]" name="admin_contact[__INDEX__][label_input]">
        </li>
        <li>
        <li class="tg-list-item row">
            <span>Required</span>
            <input class=" tgl tgl-skewed"
                   type="checkbox"
                   id="admin_contact[__INDEX__][require_input]"
                   name="admin_contact[__INDEX__][require_input]">
            <label class="tgl-btn pl-5 " data-tg-off="Non" data-tg-on="Oui" for="admin_contact[__INDEX__][require_input]"></label>
        </li>
        <li>
            <label for="admin_contact[__INDEX__][placeholder_input]">Placeholder</label>
            <input type="text" id="admin_contact[__INDEX__][placeholder_input]" name="admin_contact[__INDEX__][placeholder_input]">
        </li>
        <li>
            <input type="hidden" name="admin_contact[__INDEX__][position_input]" class="input-position" value="__INDEX__">
            <input type="hidden" name="admin_contact[__INDEX__][id_input]" class="input-id" value="">
        </li>
        <li>
            <button type="button" class="btn delete-button" data-index="__INDEX__">-</button>
        </li>
    </ul>
</section>