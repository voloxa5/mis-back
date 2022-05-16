--10.Вставка таблицы связи задание-физ.лицо
insert into proger.task_humans(
kaskad_id,
TASK_ID,
HUMAN_ID,
TASK_HUMAN_ROLE_ID,
created_at,
updated_at,
created_at_p
)
select
id_obj,
TASKS.ID,
HUMANS.ID,
(select id from PROGER.DICT_TASK_HUMAN_ROLES where kaskad_id=P_300) TASK_HUMAN_ROLE_ID,
date_reg,
date_modif,
sysdate
from K_0540.T_22, PROGER.TASKS,PROGER.HUMANS
where
T_22.id_obj_1=TASKS.kaskad_id
and T_22.id_obj_2=HUMANS.kaskad_id
and not exists (select 1 from PROGER.TASK_HUMANS where kaskad_id=id_obj)
and exists (select 1 from k_0540.t_22 where id_obj_1=:v_id_z)
