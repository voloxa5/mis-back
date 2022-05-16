-- обновление user_id в proger.employees
update proger.employees
set user_id=(select id from proger.users where employees.id_kaskad = users.id_kaskad)
