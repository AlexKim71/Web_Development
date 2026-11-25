using System.ComponentModel.DataAnnotations;
namespace AngularApi.Models;

// Id створює сервер; клієнт надсилає тільки поля форми.
public sealed class RoomInput
{
    [Required(ErrorMessage = "Вкажіть номер кімнати.")]
    [StringLength(10, MinimumLength = 1,
        ErrorMessage = "Номер кімнати: від 1 до 10 символів.")]
    public string Number { get; set; } = "";

    [Required(ErrorMessage = "Оберіть категорію.")]
    [AllowedValues("Стандарт", "Комфорт", "Сімейний", "Люкс",
        ErrorMessage = "Категорія: Стандарт, Комфорт, Сімейний або Люкс.")]
    public string Category { get; set; } = "";

    [Range(1, 8, ErrorMessage = "Місткість: ціле число від 1 до 8 осіб.")]
    public int Capacity { get; set; }

    [Range(0, 50, ErrorMessage = "Поверх: ціле число від 0 до 50.")]
    public int Floor { get; set; }

    [Range(1, 100000,
        ErrorMessage = "Вартість ночі: від 1 до 100000 грн.")]
    public decimal PricePerNight { get; set; }

    public bool IsAvailable { get; set; }
}
