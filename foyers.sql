CREATE TABLE IF NOT EXISTS public.foyers
(
    id integer NOT NULL DEFAULT nextval('foyers_id_seq'::regclass),
    geom geometry(Point,4326),
    id_foyer character varying COLLATE pg_catalog."default",
    typ_foyer character varying COLLATE pg_catalog."default",
    typ_lampe character varying COLLATE pg_catalog."default",
    rendement character varying COLLATE pg_catalog."default",
    puissance character varying COLLATE pg_catalog."default",
    "flux_ lumi" character varying COLLATE pg_catalog."default",
    tempuratur character varying COLLATE pg_catalog."default",
    puissanc_1 character varying COLLATE pg_catalog."default",
    puissanc_2 character varying COLLATE pg_catalog."default",
    module_cpl character varying COLLATE pg_catalog."default",
    materiaux character varying COLLATE pg_catalog."default",
    forme_vasq character varying COLLATE pg_catalog."default",
    etat_vasqu character varying COLLATE pg_catalog."default",
    vasque character varying COLLATE pg_catalog."default",
    ip character varying COLLATE pg_catalog."default",
    ik character varying COLLATE pg_catalog."default",
    date character varying COLLATE pg_catalog."default",
    etat_foyer character varying COLLATE pg_catalog."default",
    x double precision,
    y double precision,
    photo character varying COLLATE pg_catalog."default",
    lastsurvey date,
    created date,
    createdby character varying(25) COLLATE pg_catalog."default",
    modifiedby character varying(25) COLLATE pg_catalog."default",
    modified date,
    CONSTRAINT foyers_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.foyers
    OWNER to postgres;
-- Index: sidx_foyers_geom

-- DROP INDEX IF EXISTS public.sidx_foyers_geom;

CREATE INDEX IF NOT EXISTS sidx_foyers_geom
    ON public.foyers USING gist
    (geom)
    TABLESPACE pg_default;




