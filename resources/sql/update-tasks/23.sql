--23.пометить транспорт, если оно отстутствует в К.
update proger.vehicles set vehicles.kaskad_id=0, vehicles.updated_at_p=sysdate
where not exists
(
  select 1 from k_0540.t_12 WHERE vehicles.kaskad_id=t_12.id_obj
)
and (sysdate-vehicles.created_at_p)<20
