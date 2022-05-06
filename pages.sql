-- Table: public.pages

-- DROP TABLE IF EXISTS public.pages;

CREATE TABLE IF NOT EXISTS public.pages
(
    id integer NOT NULL DEFAULT nextval('pages_id_seq'::regclass),
    name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    description text COLLATE pg_catalog."default",
    url character varying(255) COLLATE pg_catalog."default" NOT NULL,
    group_id integer NOT NULL,
    CONSTRAINT pages_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.pages
    OWNER to postgres;