use Apuntes;

delimiter \\

    create trigger puntuacion_max 
        before insert on COMENTARIOS for each row
        begin
            if (NEW.puntuacion < 5 and New.puntuacion > 0) then
                set NEW.puntuacion = NEW.puntuacion
            end if;
        end
    \\

delimiter ;