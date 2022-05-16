--9.пометить физ.лицо, если оно отстутствует в К.
update proger.humans set humans.kaskad_id=0, humans.UPDATED_AT_P=sysdate
where not exists
(
  select 1 from k_0540.t_10 WHERE humans.kaskad_id=t_10.id_obj
)
and (sysdate-humans.created_at_p)<20
