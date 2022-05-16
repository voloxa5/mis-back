--установка user_id для личных групп
update proger.groups
set user_id = (select id from proger.users where users.id_kaskad = groups.id_kaskad)
