--15.пометить юр.лицо, если оно отстутствует в К.
update proger.legal_entities set legal_entities.kaskad_id=0, legal_entities.updated_at_p=sysdate
where not exists
(
  select 1 from k_0540.t_11 WHERE legal_entities.kaskad_id=t_11.id_obj
)
and (sysdate-legal_entities.created_at_p)<20
