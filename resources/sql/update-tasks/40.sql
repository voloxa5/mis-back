--40.пометить отсутствующую таблицу связи физ.лицо-адрес в к
update proger.human_addresses set kaskad_id=0, updated_at_p=sysdate
where not exists
(
  select 1 from k_0540.t_53 WHERE human_addresses.kaskad_id=t_53.id_obj
)
and (sysdate-human_addresses.created_at_p)<20
