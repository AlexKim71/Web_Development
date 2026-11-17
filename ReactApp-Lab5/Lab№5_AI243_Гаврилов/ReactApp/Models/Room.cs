namespace ReactApp.Models;

public sealed class Room
{
    public string Id { get; set; } = string.Empty;
    public string Number { get; set; } = string.Empty;
    public string Category { get; set; } = string.Empty;
    public int Capacity { get; set; }
    public int Floor { get; set; }
    public decimal PricePerNight { get; set; }
    public bool IsAvailable { get; set; }
}
