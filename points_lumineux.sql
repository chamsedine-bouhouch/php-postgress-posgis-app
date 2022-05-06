CREATE TABLE IF NOT EXISTS public.points_lumineux
(
    id integer NOT NULL DEFAULT nextval('points_lumineux_id_seq'::regclass),
    geom geometry(Point,4326),
    id_poteau character varying COLLATE pg_catalog."default",
    x double precision,
    y double precision,
    zone character varying COLLATE pg_catalog."default",
    armoire character varying COLLATE pg_catalog."default",
    depart character varying COLLATE pg_catalog."default",
    "type_ supp" character varying COLLATE pg_catalog."default",
    materiaux character varying COLLATE pg_catalog."default",
    date_insta character varying COLLATE pg_catalog."default",
    hauteur character varying COLLATE pg_catalog."default",
    dimension character varying COLLATE pg_catalog."default",
    inclinaiso character varying COLLATE pg_catalog."default",
    fixation character varying COLLATE pg_catalog."default",
    puissance character varying COLLATE pg_catalog."default",
    largeur_vo character varying COLLATE pg_catalog."default",
    dispositio character varying COLLATE pg_catalog."default",
    ballast character varying COLLATE pg_catalog."default",
    alimentati character varying COLLATE pg_catalog."default",
    reseau character varying COLLATE pg_catalog."default",
    coupe_circ character varying COLLATE pg_catalog."default",
    "mise _terr" character varying COLLATE pg_catalog."default",
    calibre_fu character varying COLLATE pg_catalog."default",
    section_ca character varying COLLATE pg_catalog."default",
    etat_supp character varying COLLATE pg_catalog."default",
    nb_foyers integer,
    photo character varying COLLATE pg_catalog."default",
    pl_id integer,
    lastsurvey date,
    created date,
    createdby character varying(25) COLLATE pg_catalog."default",
    modifiedby character varying(25) COLLATE pg_catalog."default",
    modified date,
    CONSTRAINT points_lumineux_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.points_lumineux
    OWNER to postgres;
-- Index: sidx_points_lumineux_geom

-- DROP INDEX IF EXISTS public.sidx_points_lumineux_geom;

CREATE INDEX IF NOT EXISTS sidx_points_lumineux_geom
    ON public.points_lumineux USING gist
    (geom)
    TABLESPACE pg_default;



