--16.Вставка таблицы связи задание-юр.лицо
insert into proger.task_legal_entities(
kaskad_id,
TASK_ID,
legal_entity_ID,
TASK_legal_entity_ROLE_ID,
created_at,
updated_at,
created_at_p
)
select
id_obj,
TASKS.ID,
legal_entities.ID,
(select id from PROGER.DICT_TASK_legal_entity_ROLES where kaskad_id=P_310) TASK_legal_entity_ROLE_ID,
date_reg,
date_modif,
sysdate
from K_0540.T_23, PROGER.TASKS,PROGER.legal_entities
where
T_23.id_obj_1=TASKS.kaskad_id
and T_23.id_obj_2=legal_entities.kaskad_id
and not exists (select 1 from PROGER.task_legal_entities where kaskad_id=id_obj)
and exists (select 1 from k_0540.t_23 where id_obj_1=:v_id_z)
