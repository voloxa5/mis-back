--26.пометить отсутствующую таблицу связи задание-транспорт в к
update proger.task_vehicles set task_vehicles.kaskad_id=0, task_vehicles.updated_at_p=sysdate
where not exists
(
  select 1 from k_0540.t_25 WHERE task_vehicles.kaskad_id=t_25.id_obj
)
and (sysdate-task_vehicles.created_at_p)<20
