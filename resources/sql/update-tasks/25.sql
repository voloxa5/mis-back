--25.Обновление таблицы связи задание-транспорт
merge into PROGER.task_vehicles
using (
select
id_obj,
(select id from PROGER.DICT_TASK_vehicle_ROLES where kaskad_id=P_330) TASK_vehicle_ROLE_ID
from K_0540.T_25
where
exists (
select 1 from PROGER.TASK_vehicles
where kaskad_id=id_obj and TASK_vehicles.updated_at_p<T_25.date_modif
)
and exists (select 1 from k_0540.t_25 where id_obj_1=:v_id_z)
) source
on (TASK_vehicles.kaskad_id=source.id_obj)
when matched then update set
TASK_vehicles.TASK_vehicle_ROLE_ID=source.TASK_vehicle_ROLE_ID,
TASK_vehicles.updated_at_p=sysdate
