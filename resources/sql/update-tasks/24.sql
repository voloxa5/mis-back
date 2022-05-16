--24.Вставка таблицы связи задание-транспорт
insert into proger.task_vehicles(
kaskad_id,
TASK_ID,
vehicle_ID,
TASK_vehicle_ROLE_ID,
created_at,
updated_at,
created_at_p
)
select
id_obj,
TASKS.ID,
vehicles.ID,
(select id from PROGER.DICT_TASK_vehicle_ROLES where kaskad_id=P_330) TASK_vehicle_ROLE_ID,
date_reg,
date_modif,
sysdate
from K_0540.T_25, PROGER.TASKS,PROGER.vehicles
where
T_25.id_obj_1=TASKS.kaskad_id
and T_25.id_obj_2=vehicles.kaskad_id
and not exists (select 1 from PROGER.task_vehicles where kaskad_id=id_obj)
and exists (select 1 from k_0540.t_25 where id_obj_1=:v_id_z)
