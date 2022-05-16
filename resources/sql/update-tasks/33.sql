--33.пометить адрес, если оно отстутствует в К.
update proger.addresses set addresses.kaskad_id=0, addresses.updated_at_p=sysdate
where not exists
(
  select 1 from k_0540.t_13 WHERE addresses.kaskad_id=t_13.id_obj
)
and (sysdate-addresses.created_at_p)<20
