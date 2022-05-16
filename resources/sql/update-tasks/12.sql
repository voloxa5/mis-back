--12.пометить отсутствующие связи задание-физ.лицо в к
update proger.TASK_HUMANS set TASK_HUMANS.kaskad_id=0, TASK_HUMANS.updated_at_p=sysdate
where not exists
(
  select 1 from k_0540.t_22 WHERE TASK_HUMANS.kaskad_id=t_22.id_obj
)
and (sysdate-TASK_HUMANS.created_at_p)<20
