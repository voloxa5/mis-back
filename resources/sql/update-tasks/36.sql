--36.пометить отсутствующую таблицу связи задание-адрес в к
update proger.task_addresses set task_addresses.kaskad_id=0, task_addresses.updated_at_p=sysdate
where not exists
(
  select 1 from k_0540.t_24 WHERE task_addresses.kaskad_id=t_24.id_obj
)
and (sysdate-task_addresses.created_at_p)<20
