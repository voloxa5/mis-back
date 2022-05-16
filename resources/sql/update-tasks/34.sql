--34.Вставка таблицы связи задание-адрес
insert into proger.task_addresses(
kaskad_id,
TASK_ID,
address_ID,
TASK_address_ROLE_ID,
created_at,
updated_at,
created_at_p
)
select
T_24.id_obj,
TASKS.ID,
addresses.ID,
(select id from PROGER.DICT_TASK_address_ROLES where DICT_TASK_address_ROLES.kaskad_id=P_320) TASK_address_ROLE_ID,
T_24.date_reg,
T_24.date_modif,
sysdate
from K_0540.T_24, PROGER.TASKS,PROGER.addresses
where
T_24.id_obj_1=TASKS.kaskad_id
and T_24.id_obj_2=addresses.kaskad_id
and not exists (select 1 from PROGER.task_addresses where task_addresses.kaskad_id=T_24.id_obj)
and exists (select 1 from k_0540.t_24 where id_obj_1=:v_id_z)
