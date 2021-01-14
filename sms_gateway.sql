PGDMP                          y            sms_gateway    13.0    13.0 1    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16394    sms_gateway    DATABASE     j   CREATE DATABASE sms_gateway WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'English_Pakistan.1252';
    DROP DATABASE sms_gateway;
                postgres    false            �            1259    16441    sms_responses    TABLE     �   CREATE TABLE public.sms_responses (
    sr_id bigint NOT NULL,
    response text,
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint
);
 !   DROP TABLE public.sms_responses;
       public         heap    postgres    false            �            1259    16439    sms_responses_sr_id_seq    SEQUENCE     �   CREATE SEQUENCE public.sms_responses_sr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.sms_responses_sr_id_seq;
       public          postgres    false    209            �           0    0    sms_responses_sr_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.sms_responses_sr_id_seq OWNED BY public.sms_responses.sr_id;
          public          postgres    false    208            �            1259    32922    tbl_carriers    TABLE     �   CREATE TABLE public.tbl_carriers (
    carrier_id bigint NOT NULL,
    name character varying,
    function character varying,
    is_active bigint,
    created_at date,
    updated_at date,
    deleted_at date,
    label_id character varying
);
     DROP TABLE public.tbl_carriers;
       public         heap    postgres    false            �            1259    32920    tbl_carriers_carrier_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tbl_carriers_carrier_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.tbl_carriers_carrier_id_seq;
       public          postgres    false    217            �           0    0    tbl_carriers_carrier_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.tbl_carriers_carrier_id_seq OWNED BY public.tbl_carriers.carrier_id;
          public          postgres    false    216            �            1259    16452 
   tbl_labels    TABLE     �   CREATE TABLE public.tbl_labels (
    label_id bigint NOT NULL,
    label_name character varying(300),
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint
);
    DROP TABLE public.tbl_labels;
       public         heap    postgres    false            �            1259    16450    tbl_labels_label_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tbl_labels_label_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.tbl_labels_label_id_seq;
       public          postgres    false    211            �           0    0    tbl_labels_label_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.tbl_labels_label_id_seq OWNED BY public.tbl_labels.label_id;
          public          postgres    false    210            �            1259    16419    tbl_numbers    TABLE     �   CREATE TABLE public.tbl_numbers (
    number_id bigint NOT NULL,
    number character varying(100),
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint,
    label_id character varying,
    carrier_id bigint
);
    DROP TABLE public.tbl_numbers;
       public         heap    postgres    false            �            1259    16417    tbl_numbers_number_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tbl_numbers_number_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.tbl_numbers_number_id_seq;
       public          postgres    false    205            �           0    0    tbl_numbers_number_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.tbl_numbers_number_id_seq OWNED BY public.tbl_numbers.number_id;
          public          postgres    false    204            �            1259    16397 	   tbl_roles    TABLE     _   CREATE TABLE public.tbl_roles (
    role_id bigint NOT NULL,
    name character varying(50)
);
    DROP TABLE public.tbl_roles;
       public         heap    postgres    false            �            1259    16395    tbl_roles_role_id_seq    SEQUENCE     ~   CREATE SEQUENCE public.tbl_roles_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.tbl_roles_role_id_seq;
       public          postgres    false    201            �           0    0    tbl_roles_role_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.tbl_roles_role_id_seq OWNED BY public.tbl_roles.role_id;
          public          postgres    false    200            �            1259    16514    tbl_senders    TABLE     �   CREATE TABLE public.tbl_senders (
    sender_id bigint NOT NULL,
    number character varying,
    alias character varying,
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint NOT NULL
);
    DROP TABLE public.tbl_senders;
       public         heap    postgres    false            �            1259    16512    tbl_senders_sender_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tbl_senders_sender_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.tbl_senders_sender_id_seq;
       public          postgres    false    215                        0    0    tbl_senders_sender_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.tbl_senders_sender_id_seq OWNED BY public.tbl_senders.sender_id;
          public          postgres    false    214            �            1259    16498    tbl_sms_logs    TABLE     *  CREATE TABLE public.tbl_sms_logs (
    sl_id bigint NOT NULL,
    sender_id bigint,
    receiver_id bigint,
    message text,
    status bigint,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at date,
    is_active bigint,
    user_id bigint
);
     DROP TABLE public.tbl_sms_logs;
       public         heap    postgres    false            �            1259    16486    tbl_sms_logs_sl_id_seq    SEQUENCE        CREATE SEQUENCE public.tbl_sms_logs_sl_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.tbl_sms_logs_sl_id_seq;
       public          postgres    false    213                       0    0    tbl_sms_logs_sl_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.tbl_sms_logs_sl_id_seq OWNED BY public.tbl_sms_logs.sl_id;
          public          postgres    false    212            �            1259    16431    tbl_user_numbers    TABLE     �   CREATE TABLE public.tbl_user_numbers (
    un_id bigint NOT NULL,
    user_id bigint,
    number_id bigint,
    is_active bigint,
    created_at date,
    updated_at date,
    deleted_at date
);
 $   DROP TABLE public.tbl_user_numbers;
       public         heap    postgres    false            �            1259    16425    tbl_user_numbers_un_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tbl_user_numbers_un_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.tbl_user_numbers_un_id_seq;
       public          postgres    false    207                       0    0    tbl_user_numbers_un_id_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.tbl_user_numbers_un_id_seq OWNED BY public.tbl_user_numbers.un_id;
          public          postgres    false    206            �            1259    16407 	   tbl_users    TABLE     4  CREATE TABLE public.tbl_users (
    user_id bigint NOT NULL,
    fullname character varying(200),
    role_id bigint,
    email character varying(200),
    password character varying(200),
    created_at date,
    updated_at date,
    deleted_at date,
    is_active bigint,
    label_id character varying
);
    DROP TABLE public.tbl_users;
       public         heap    postgres    false            �            1259    16403    tbl_users_user_id_seq    SEQUENCE     ~   CREATE SEQUENCE public.tbl_users_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.tbl_users_user_id_seq;
       public          postgres    false    203                       0    0    tbl_users_user_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.tbl_users_user_id_seq OWNED BY public.tbl_users.user_id;
          public          postgres    false    202            \           2604    16444    sms_responses sr_id    DEFAULT     z   ALTER TABLE ONLY public.sms_responses ALTER COLUMN sr_id SET DEFAULT nextval('public.sms_responses_sr_id_seq'::regclass);
 B   ALTER TABLE public.sms_responses ALTER COLUMN sr_id DROP DEFAULT;
       public          postgres    false    208    209    209            `           2604    32925    tbl_carriers carrier_id    DEFAULT     �   ALTER TABLE ONLY public.tbl_carriers ALTER COLUMN carrier_id SET DEFAULT nextval('public.tbl_carriers_carrier_id_seq'::regclass);
 F   ALTER TABLE public.tbl_carriers ALTER COLUMN carrier_id DROP DEFAULT;
       public          postgres    false    216    217    217            ]           2604    16455    tbl_labels label_id    DEFAULT     z   ALTER TABLE ONLY public.tbl_labels ALTER COLUMN label_id SET DEFAULT nextval('public.tbl_labels_label_id_seq'::regclass);
 B   ALTER TABLE public.tbl_labels ALTER COLUMN label_id DROP DEFAULT;
       public          postgres    false    211    210    211            Z           2604    16422    tbl_numbers number_id    DEFAULT     ~   ALTER TABLE ONLY public.tbl_numbers ALTER COLUMN number_id SET DEFAULT nextval('public.tbl_numbers_number_id_seq'::regclass);
 D   ALTER TABLE public.tbl_numbers ALTER COLUMN number_id DROP DEFAULT;
       public          postgres    false    205    204    205            X           2604    16400    tbl_roles role_id    DEFAULT     v   ALTER TABLE ONLY public.tbl_roles ALTER COLUMN role_id SET DEFAULT nextval('public.tbl_roles_role_id_seq'::regclass);
 @   ALTER TABLE public.tbl_roles ALTER COLUMN role_id DROP DEFAULT;
       public          postgres    false    200    201    201            _           2604    16517    tbl_senders sender_id    DEFAULT     ~   ALTER TABLE ONLY public.tbl_senders ALTER COLUMN sender_id SET DEFAULT nextval('public.tbl_senders_sender_id_seq'::regclass);
 D   ALTER TABLE public.tbl_senders ALTER COLUMN sender_id DROP DEFAULT;
       public          postgres    false    214    215    215            ^           2604    16501    tbl_sms_logs sl_id    DEFAULT     x   ALTER TABLE ONLY public.tbl_sms_logs ALTER COLUMN sl_id SET DEFAULT nextval('public.tbl_sms_logs_sl_id_seq'::regclass);
 A   ALTER TABLE public.tbl_sms_logs ALTER COLUMN sl_id DROP DEFAULT;
       public          postgres    false    212    213    213            [           2604    16434    tbl_user_numbers un_id    DEFAULT     �   ALTER TABLE ONLY public.tbl_user_numbers ALTER COLUMN un_id SET DEFAULT nextval('public.tbl_user_numbers_un_id_seq'::regclass);
 E   ALTER TABLE public.tbl_user_numbers ALTER COLUMN un_id DROP DEFAULT;
       public          postgres    false    207    206    207            Y           2604    16410    tbl_users user_id    DEFAULT     v   ALTER TABLE ONLY public.tbl_users ALTER COLUMN user_id SET DEFAULT nextval('public.tbl_users_user_id_seq'::regclass);
 @   ALTER TABLE public.tbl_users ALTER COLUMN user_id DROP DEFAULT;
       public          postgres    false    202    203    203            j           2606    16449     sms_responses sms_responses_pkey 
   CONSTRAINT     a   ALTER TABLE ONLY public.sms_responses
    ADD CONSTRAINT sms_responses_pkey PRIMARY KEY (sr_id);
 J   ALTER TABLE ONLY public.sms_responses DROP CONSTRAINT sms_responses_pkey;
       public            postgres    false    209            r           2606    32930    tbl_carriers tbl_carriers_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.tbl_carriers
    ADD CONSTRAINT tbl_carriers_pkey PRIMARY KEY (carrier_id);
 H   ALTER TABLE ONLY public.tbl_carriers DROP CONSTRAINT tbl_carriers_pkey;
       public            postgres    false    217            l           2606    16457    tbl_labels tbl_labels_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.tbl_labels
    ADD CONSTRAINT tbl_labels_pkey PRIMARY KEY (label_id);
 D   ALTER TABLE ONLY public.tbl_labels DROP CONSTRAINT tbl_labels_pkey;
       public            postgres    false    211            f           2606    16424    tbl_numbers tbl_numbers_pkey 
   CONSTRAINT     a   ALTER TABLE ONLY public.tbl_numbers
    ADD CONSTRAINT tbl_numbers_pkey PRIMARY KEY (number_id);
 F   ALTER TABLE ONLY public.tbl_numbers DROP CONSTRAINT tbl_numbers_pkey;
       public            postgres    false    205            b           2606    16402    tbl_roles tbl_roles_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.tbl_roles
    ADD CONSTRAINT tbl_roles_pkey PRIMARY KEY (role_id);
 B   ALTER TABLE ONLY public.tbl_roles DROP CONSTRAINT tbl_roles_pkey;
       public            postgres    false    201            p           2606    16522    tbl_senders tbl_senders_pkey 
   CONSTRAINT     a   ALTER TABLE ONLY public.tbl_senders
    ADD CONSTRAINT tbl_senders_pkey PRIMARY KEY (sender_id);
 F   ALTER TABLE ONLY public.tbl_senders DROP CONSTRAINT tbl_senders_pkey;
       public            postgres    false    215            n           2606    16511    tbl_sms_logs tbl_sms_logs_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.tbl_sms_logs
    ADD CONSTRAINT tbl_sms_logs_pkey PRIMARY KEY (sl_id);
 H   ALTER TABLE ONLY public.tbl_sms_logs DROP CONSTRAINT tbl_sms_logs_pkey;
       public            postgres    false    213            h           2606    16438 &   tbl_user_numbers tbl_user_numbers_pkey 
   CONSTRAINT     g   ALTER TABLE ONLY public.tbl_user_numbers
    ADD CONSTRAINT tbl_user_numbers_pkey PRIMARY KEY (un_id);
 P   ALTER TABLE ONLY public.tbl_user_numbers DROP CONSTRAINT tbl_user_numbers_pkey;
       public            postgres    false    207            d           2606    16416    tbl_users tbl_users_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.tbl_users
    ADD CONSTRAINT tbl_users_pkey PRIMARY KEY (user_id);
 B   ALTER TABLE ONLY public.tbl_users DROP CONSTRAINT tbl_users_pkey;
       public            postgres    false    203           