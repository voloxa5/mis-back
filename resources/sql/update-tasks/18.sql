--18.пометить юр.лица отсутствующие в к
update proger.task_legal_entities set task_legal_entities.kaskad_id=0, task_legal_entities.updated_at_p=sysdate
where not exists
(
  select 1 from k_0540.t_23 WHERE task_legal_entities.kaskad_id=t_23.id_obj
)
and (sysdate-task_legal_entities.created_at_p)<20
