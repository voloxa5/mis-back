--35.Обновление таблицы связи задание-адрес
merge into PROGER.task_addresses
using (
select
id_obj,
(select id from PROGER.DICT_TASK_address_ROLES where kaskad_id=P_320) TASK_address_ROLE_ID
from K_0540.T_24
where
exists (
select 1 from PROGER.TASK_addresses
where kaskad_id=id_obj and TASK_addresses.updated_at_p<T_24.date_modif
)
and exists (select 1 from k_0540.t_24 where id_obj_1=:v_id_z)
) source
on (TASK_addresses.kaskad_id=source.id_obj)
when matched then update set
TASK_addresses.TASK_address_ROLE_ID=source.TASK_address_ROLE_ID,
TASK_addresses.updated_at_p=sysdate
