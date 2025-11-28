package com.example.musicapp.api

import retrofit2.http.GET
import retrofit2.http.Query

interface ApiService {

    @GET("search")
    suspend fun searchSongs(
        @Query("term") query: String,
        @Query("media") media: String = "music"
    ): SearchResponse
}