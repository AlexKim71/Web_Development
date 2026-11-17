using System.ComponentModel.DataAnnotations;

namespace ReactApp.Models;

public sealed class RoomInput
{
    [Required(ErrorMessage = "Вкажіть номер кімнати.")]
    [StringLength(10, MinimumLength = 1, ErrorMessage = "Номер: до 10 символів.")]
    public string Number { get; set; } = string.Empty;

    [Required(ErrorMessage = "Оберіть категорію.")]
    public string Category { get; set; } = string.Empty;

    [Range(1, 8, ErrorMessage = "Місткість: від 1 до 8 осіб.")]
    public int Capacity { get; set; }

    [Range(0, 50, ErrorMessage = "Поверх: від 0 до 50.")]
    public int Floor { get; set; }

    [Range(1, 100000, ErrorMessage = "Вартість ночі: від 1 до 100000 грн.")]
    public decimal PricePerNight { get; set; }

    public bool IsAvailable { get; set; }
}
